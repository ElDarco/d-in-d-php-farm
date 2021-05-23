import {createModule} from 'vuexok'
import store from '@/store'
import Cookies from 'js-cookie'
import {MockServerProvider} from "@/providers/gateway/mock-server-provider";
import {AxiosResponse} from "axios";

export const settingsMockServerModule = createModule(store, 'settings-mock-server', {
  namespaced: true,
  state: {
    nSpaces: [] as NSpace[],
    nRequests: [] as NRequest[],
    nSettings: [] as NSettings[],
    selectedNSpace: null as unknown as NSpace,
    selectedNRequest: null as unknown as NRequest,
    selectedNSettings: null as unknown as NSettings,
    selectedEntityType: ''
  },
  actions: {
    async restoreNSpaceFromCache(state, doneCallback: Function | undefined = undefined) {
      const mockServerProvider: MockServerProvider = new MockServerProvider();
      const rawNSpace = JSON.parse(Cookies.get('nspaces') ?? '[]') as NSpaceInCache[];
      settingsMockServerModule.mutations.clearNSpaces();
      settingsMockServerModule.mutations.clearNSetting();
      settingsMockServerModule.mutations.clearNRequests();
      settingsMockServerModule.mutations.clearSelectedEntityType();
      for (const element of rawNSpace) {
        await mockServerProvider.syncNSpace(element, (response: AxiosResponse) => {
          settingsMockServerModule.mutations.addNSpace(response.data as NSpace);
        });
      }
      if (doneCallback != undefined) {
        doneCallback();
      }
    },
    async refreshSingleNSpace(state, object) {
      const mockServerProvider: MockServerProvider = new MockServerProvider();
      await mockServerProvider.syncNSpace(object.nSpace, (response: AxiosResponse) => {
        const index = settingsMockServerModule.state.nSpaces.findIndex((element: NSpace) => {
          return element.id === object.nSpace.id;
        });
        settingsMockServerModule.state.nSpaces[index] = response.data as NSpace
        settingsMockServerModule.mutations.useNSpace(response.data as NSpace)
      });
      if (object.doneCallback != undefined) {
        object.doneCallback();
      }
    },
    persistNSpaceToCache() {
      const toCache = [] as NSpaceInCache[];
      settingsMockServerModule.getters.getNSpaces().forEach((nSpace: NSpace) => {
        toCache.push({"id": nSpace.id, "name": nSpace.name} as NSpaceInCache)
      })
      Cookies.set('nspaces', toCache)
    }
  },
  mutations: {
    addNSpace(state, payload: NSpace) {
      state.nSpaces.push(payload);
    },
    clearNSpaces(state) {
      state.nSpaces = [];
    },
    clearNSetting(state) {
      state.nSettings = [];
    },
    clearNRequests(state) {
      state.nRequests = [];
    },
    clearSelectedEntityType(state) {
      state.selectedEntityType = '';
    },
    useNSpace(state, payload: NSpace) {
      state.selectedEntityType = 'nspace';
      state.selectedNSpace = payload;
      state.nRequests = payload.requests.reverse();
      state.nSettings = payload.settings;
    },
    useNRequest(state, payload: NRequest) {
      state.selectedEntityType = 'nrequest';
      state.selectedNRequest = payload;
    },
    useNSettings(state, payload: NSettings) {
      state.selectedEntityType = 'nsettings';
      state.selectedNSettings = payload;
    }
  },
  getters: {
    getNSpaceByID(state) {
      return (id: string) => state.nSpaces.find((element: NSpace) => {
        return element.id === id;
      });
    },
    getNRequestByID(state) {
      return (id: string) => state.nRequests.find((element: NRequest) => {
        return element.id === id;
      });
    },
    getNSpaces(state) {
      return () => state.nSpaces as NSpace[];
    },
    getSelectedNSpace(state) {
      return () => state.selectedNSpace as NSpace;
    },
    getSelectedNRequest(state) {
      return () => state.selectedNRequest as NRequest;
    },
    getSelectedNSettings(state) {
      return () => state.selectedNSettings as NSettings;
    },
    getSelectedEntityType(state) {
      return () => state.selectedEntityType;
    },
  },
})
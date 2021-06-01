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
    selectedNSpace: undefined as NSpace | undefined,
    selectedNRequest: undefined as NRequest | undefined,
    selectedNSettings: undefined as NSettings | undefined,
    templateNSettings: undefined as NSettings | undefined,
    selectedEntityType: '',
    nSettingsEditorLanguage: 'json',
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
          response.data.urlToMock = process.env.VUE_APP_MOCK_SERVER_HOST_URL + '/n/' + response.data.id
          settingsMockServerModule.mutations.addNSpace(response.data as NSpace);
        });
      }
      settingsMockServerModule.mutations.defaultSelectedEntityType();
      if (doneCallback != undefined) {
        doneCallback();
      }
    },
    async refreshSingleNSpace(state, object) {
      settingsMockServerModule.mutations.clearNRequests();
      settingsMockServerModule.mutations.clearNSetting();
      settingsMockServerModule.mutations.clearSelectedNRequests();
      settingsMockServerModule.mutations.clearSelectedEntityType();
      const mockServerProvider: MockServerProvider = new MockServerProvider();
      await mockServerProvider.syncNSpace(object.nSpace, (response: AxiosResponse) => {
        const index = settingsMockServerModule.state.nSpaces.findIndex((element: NSpace) => {
          return element.id === object.nSpace.id;
        });
        response.data.urlToMock = process.env.VUE_APP_MOCK_SERVER_HOST_URL + '/n/' + response.data.id
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
    deleteNSpace(state, payload: NSpace) {
      const int = state.nSpaces.findIndex((element: NSpace) => {
        return element.id === payload.id;
      });
      state.nSpaces.splice(int, 1);
      settingsMockServerModule.mutations.clearSelectedNSettings();
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
      state.selectedEntityType = 'whiteboard';
    },
    defaultSelectedEntityType(state) {
      state.selectedEntityType = '';
    },
    clearSelectedNRequests(state) {
      state.selectedNRequest = undefined;
    },
    clearSelectedNSettings(state) {
      state.selectedNSettings = undefined;
    },
    clearSelectedNSpace(state) {
      state.selectedNSpace = undefined;
    },
    useNSpace(state, payload: NSpace) {
      state.selectedEntityType = 'nspace';
      state.selectedNSpace = payload;
      state.nRequests = payload.requests;
      state.nSettings = payload.settings;
      state.selectedNRequest = undefined;
      state.selectedNSettings = undefined;
    },
    useNRequest(state, payload: NRequest) {
      state.selectedEntityType = 'nrequest';
      state.selectedNRequest = payload;
      state.selectedNSettings = undefined;
    },
    useNSettings(state, payload: NSettings) {
      state.selectedEntityType = 'nsettings';
      state.selectedNSettings = payload;
      state.selectedNRequest = undefined;
    },
    addTemplateNSettings(state, payload: NSettings) {
      state.templateNSettings = payload;
    },
    clearTemplateNSettings(state) {
      state.templateNSettings = undefined;
    },
    useCreateNSpace(state) {
      state.selectedEntityType = 'createnspace'
    },
    useCreateNSettings(state) {
      state.selectedEntityType = 'creatensettings'
    },
    switchNSettingsEditorToLang(state, payload: string) {
      state.nSettingsEditorLanguage = payload
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
    getNSettingsByID(state) {
      return (id: string) => state.nSettings.find((element: NSettings) => {
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
    getNSettingsEditorLand(state) {
      return () => state.nSettingsEditorLanguage;
    },
    getNSettingsTemplate(state) {
      return () => state.templateNSettings;
    },
  },
})
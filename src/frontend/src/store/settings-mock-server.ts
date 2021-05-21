import { createModule } from 'vuexok'
import store from '@/store'

export const settingsMockServerModule = createModule(store, 'settings-mock-server', {
    namespaced: true,
    state: {
        nSpaces: [] as NSpace[],
        selectedNSpace: null as unknown as NSpace,
        selectedEntityType: ''
    },
    actions: {
    },
    mutations: {
        addNSpace(state, payload: NSpace) {
            state.nSpaces.push(payload);
        },
        useNSpace(state, payload: NSpace) {
            state.selectedEntityType = 'nspace';
            state.selectedNSpace = payload;
        },
    },
    getters: {
        getNSpaceByID(state) {
            return (id: string) => state.nSpaces.find((element: NSpace) => {
                return element.id === id;
            });
        },
        getNSpaces(state) {
            return () => state.nSpaces as NSpace[];
        },
        getSelectedNSpaces(state) {
            return () => state.selectedNSpace as NSpace;
        },
        getSelectedEntityType(state) {
            return () => state.selectedEntityType;
        },
    },
})
import { createModule } from 'vuexok'
import store from '@/store'

export const settingsPhpModule = createModule(store, 'settings', {
    namespaced: true,
    state: {
        layoutType: 'rows',
    },
    actions: {
        async setRowsLayout() {
            settingsPhpModule.mutations.setLayout('rows')
        },
        async setColumnLayout() {
            settingsPhpModule.mutations.setLayout('columns')
        },
    },
    mutations: {
        setLayout(state, payload) {
            state.layoutType += payload
        },
    },
    getters: {
        getLayoutType(state) {
            return state.layoutType;
        },
    },
})
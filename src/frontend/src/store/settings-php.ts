import { createModule } from 'vuexok'
import store from '@/store'

export const settingsPhpModule = createModule(store, 'settings-php', {
    namespaced: true,
    state: {
        layoutType: 'rows',
        selectedPhpInstance: {
            phpVersion: 'None',
            status: 'deactivate',
            uuid: '',
            runUrl: '',
        }
    },
    actions: {
        async setRowsLayout() {
            settingsPhpModule.mutations.setLayout('rows')
        },
        async setColumnLayout() {
            settingsPhpModule.mutations.setLayout('columns')
        }
    },
    mutations: {
        setLayout(state, payload) {
            state.layoutType += payload
        },
        setSelectedPhpInstance(state, payload: PhpInstance) {
            state.selectedPhpInstance = payload
        }
    },
    getters: {
        getLayoutType(state) {
            return state.layoutType;
        },
    },
})
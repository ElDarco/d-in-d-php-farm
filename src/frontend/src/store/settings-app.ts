import { createModule } from 'vuexok'
import store from '@/store'

export const settingsAppModule = createModule(store, 'settings', {
    namespaced: true,
    state: {
        activeEditor: 'php',
    },
    actions: {
        async setActiveEditorToPHP() {
            settingsAppModule.mutations.setActiveEditor('php')
        },
    },
    mutations: {
        setActiveEditor(state, payload) {
            state.activeEditor += payload
        },
    },
    getters: {
        getActiveEditor(state) {
            return state.activeEditor;
        },
    },
})
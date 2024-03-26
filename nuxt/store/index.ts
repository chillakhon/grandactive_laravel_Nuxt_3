import {defineStore} from "pinia";


export const useAppStore = defineStore({
    id: 'app',
    state: () => ({
        user: null,
        adsUser: null,
    }),
})
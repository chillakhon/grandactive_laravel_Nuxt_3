import {defineStore} from "pinia";


export const useAppStore = defineStore({
    id: 'app',
    state: () => ({
        user: null,
        adsUser: null,
        sections: null,
        categories: null,
        ads: null,
        filter_params: {},
        popularAds: null,
        newAds: null,
        flash: {},
        users: null,
        message: null,
        notification: [],
    }),

})


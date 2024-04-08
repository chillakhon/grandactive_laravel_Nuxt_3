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
        flash: false,
    }),
    actions: {
        updateAdsUser(ad) {
            this.adsUser = this.adsUser.filter((item) => item.id !== ad.id)

        },
        adAdsUser(ad) {
            this.adsUser.push(ad)
        }
    }
})


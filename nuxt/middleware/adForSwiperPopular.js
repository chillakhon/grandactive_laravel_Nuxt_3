import axios from "axios";
import {useAppStore} from "~/store";

export default defineNuxtRouteMiddleware(async (to, from) => {
    //popular ads
    try {
        if (!useAppStore().popularAds) {
            await axios.get('api/popular-ads').then(res => {
                useAppStore().popularAds = res.data
            })
        }

        // new ads
        if (!useAppStore().newAds) {
            await axios.get('api/new-ads').then(res => {
                useAppStore().newAds = res.data
            })
        }

    }catch (error) {
        // @ts-ignore
        if (error.response?.status === 401){

        }
    }

})

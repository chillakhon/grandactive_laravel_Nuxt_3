import axios from "axios";
import {useAppStore} from "~/store";

export default defineNuxtRouteMiddleware(async (to, from) => {

    try {
        if (!useAppStore().adsUser) {
            if (useAppStore().user) {
                await axios.post('/api/get-ads').then((response) => {
                        useAppStore().adsUser = response.data;
                    }
                )
            }
        }

    }catch (error) {
        // @ts-ignore

    }

})

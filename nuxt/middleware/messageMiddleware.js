import axios from "axios";
import {useAppStore} from "~/store";

export default defineNuxtRouteMiddleware(async (to, from) => {

    try {
         await axios.get('api/messages').then(res => {
                useAppStore().message = res.data
            });

    }catch (error) {
        // @ts-ignore

    }

})

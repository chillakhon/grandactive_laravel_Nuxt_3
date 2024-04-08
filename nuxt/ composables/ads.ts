import axios from "axios";
import {useAppStore} from "~/store";

export const ads = ()=> {
    async function section() {
        const sections=  await axios.get('api/section')
        if (sections){
            useAppStore().sections = sections.data
        }
    }
    return {
        section
    }
}
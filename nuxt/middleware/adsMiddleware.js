import axios from "axios";
import {useAppStore} from "~/store";

export default defineNuxtRouteMiddleware(async (to, from) => {

    try {
        if (!useAppStore().sections){
            await axios.get('api/section').then(res => {
                useAppStore().sections = res.data
            });
        }

        if (!useAppStore().categories){
            await axios.get('api/categories').then(res => {
                useAppStore().categories = res.data.map((category) => ({
                    ...category,
                    isOpen: false,
                }))
            })
        }

//section
        let section;
        if(useRoute().params.section){
            section = useAppStore().sections.find((item) => item.urlName == useRoute().params.section);
            if(section){
                useAppStore().filter_params.section = section
            }
        }


        //category
        let category;
        if(useRoute().params.category){
            category = useAppStore().categories.find((item) => item.url_name == useRoute().params.category);
            if(category){
                useAppStore().filter_params.category = category
            }
        }
        //sub-category
        let subCategory;
        if(useRoute().params.subCategory){
           const sub_category  = useAppStore().categories.forEach((item) => {
               if(item.subcategory.length > 0){
                   item.subcategory.forEach((sub) => {
                       if(sub.url_name == useRoute().params.subCategory){
                           subCategory = sub;
                       }
                   })
               }
            })
            if(subCategory){
                useAppStore().filter_params.subCategory = subCategory
            }

        }


        if (useAppStore().filter_params){
            const formData = new FormData()

            if (useRoute().params?.section){
                formData.append('section_id', useAppStore().filter_params.section.id)
            }

            if (useRoute().params?.category){
                formData.append('category_id', useAppStore().filter_params.category.id)
            }
            if (useRoute().params?.subCategory){
                formData.append('sub_category_id', useAppStore().filter_params.subCategory.id)
            }

            if (!useRoute().params?.section){
                return
            }
            await axios.post('api/ads', formData).then(res => {
                useAppStore().ads = res.data
            })
        }

    }catch (error) {
        // @ts-ignore
        if (error.response?.status === 401){

        }
    }

})

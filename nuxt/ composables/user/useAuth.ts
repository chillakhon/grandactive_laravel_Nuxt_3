import axios from "axios";

export const useAuth = ()=> {
    async function login(form: string) {
        const res = await axios.post('/api/login', form);
        useCookie('token').value = res.data.token
        axios.defaults.headers.common['Authorization'] = `Bearer ${res.data.token}`
        window.location.reload()
    }
    return {
        login
    }
}
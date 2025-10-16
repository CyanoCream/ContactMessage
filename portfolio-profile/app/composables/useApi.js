import axios from 'axios'

const api = axios.create({
    baseURL: process.env.NUXT_PUBLIC_API_BASE_URL || 'http://127.0.0.1:8000',
    headers: {
        'Content-Type': 'application/json',
    },
})

export const useApi = () => {
    const post = async (url, data) => {
        try {
            const response = await api.post(url, data)
            return response.data
        } catch (error) {
            throw error.response?.data || error.message
        }
    }

    return {
        post,
    }
}
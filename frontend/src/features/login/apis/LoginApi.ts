import { AxiosError } from 'axios'
import { LoginRequest } from '../types/login'
import apiClient from '@/libs/apiClient'

export type ApiErrorResponse = {
  status: number
  message: string
  data?: object
}

export const sendLogin = async (request: LoginRequest): Promise<void> => {
  await apiClient
    .post('/api/v1/users/login', request)
    .then((res) => {
      console.log(res.data)
    })
    .catch((e: AxiosError<ApiErrorResponse>) => {
      if (e.response) {
        console.error(e.response.data)
      } else {
        console.error(e)
      }
    })
}

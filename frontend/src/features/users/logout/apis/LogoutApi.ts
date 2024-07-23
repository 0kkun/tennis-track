import { AxiosError } from 'axios'
import apiClient from '@/libs/apiClient'
import { ApiErrorResponse } from '@/libs/apiClient'

export const sendLogout = async (): Promise<void> => {
  await apiClient
    .delete('/api/v1/users/sessions')
    .then((res) => {
      console.log(res.data)
      apiClient.unsetAuthToken()
    })
    .catch((e: AxiosError<ApiErrorResponse>) => {
      if (e.response) {
        console.error(e.response.data)
      } else {
        console.error(e)
      }
    })
}

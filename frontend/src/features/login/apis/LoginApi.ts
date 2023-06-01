import { AxiosError, isAxiosError } from 'axios'
import { LoginRequest } from '../types/login'
import apiClient from '@/libs/apiClient'
import { ApiSuccessResponse, ApiErrorResponse } from '@/libs/apiClient'

export const sendLogin = async (
  request: LoginRequest,
): Promise<ApiSuccessResponse> => {
  try {
    const response = await apiClient.post('/api/v1/users/login', request)
    console.log('Login api success!')
    return response.data
  } catch (error) {
    console.log('Login api failed!')
    if (isAxiosError(error)) {
      const axiosError = error as AxiosError<ApiErrorResponse>
      if (axiosError.response) {
        console.log(axiosError.response.data)
        return axiosError.response.data
      } else {
        console.log(axiosError.message)
        throw new Error(axiosError.message)
      }
    } else {
      console.log(error)
      throw error
    }
  }
}

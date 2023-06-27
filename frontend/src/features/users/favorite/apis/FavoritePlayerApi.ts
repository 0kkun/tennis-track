import { AxiosError, isAxiosError } from 'axios'
import { AddFavoritePlayerRequest, DestroyFavoritePlayerRequest } from '../types/FavoritePlayer'
import apiClient from '@/libs/apiClient'
import { ApiSuccessResponse, ApiErrorResponse } from '@/libs/apiClient'

export const sendFetchFavoritePlayers = async (): Promise<ApiSuccessResponse> => {
  try {
    const endpoint = '/api/v1/users/favorite_players'
    const response = await apiClient.get(endpoint)
    console.log('fetch favorite players api success!')
    return response.data
  } catch (error) {
    console.log('fetch favorite players failed!')
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

export const sendAddFavoritePlayer = async (
  request: AddFavoritePlayerRequest,
): Promise<ApiSuccessResponse> => {
  try {
    const endpoint = '/api/v1/users/favorite_players'
    const response = await apiClient.post(endpoint, request)
    console.log('add favorite player api success!')
    return response.data
  } catch (error) {
    console.log('add favorite player faild!')
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

export const sendRemoveFavoritePlayer = async (
  request: DestroyFavoritePlayerRequest,
): Promise<ApiSuccessResponse> => {
  try {
    const endpoint = '/api/v1/users/favorite_players/' + request.player_id
    const response = await apiClient.delete(endpoint)
    console.log('remove favorite player api success!')
    return response.data
  } catch (error) {
    console.log('remove favorite player faild!')
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

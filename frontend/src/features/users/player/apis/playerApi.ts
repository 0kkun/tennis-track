import { AxiosError, isAxiosError } from 'axios'
import { FetchPlayersRequest } from '../types/player'
import apiClient from '@/libs/apiClient'
import { ApiSuccessResponse, ApiErrorResponse } from '@/libs/apiClient'

export const sendFetchPlayers = async (
  request: FetchPlayersRequest,
): Promise<ApiSuccessResponse> => {
  try {
    const baseEndpoint = '/api/v1/admins/players'
    const endpoint = generateEndpoint(baseEndpoint, request)
    const response = await apiClient.get(endpoint)
    console.log('fetch players api success!')
    return response.data
  } catch (error) {
    console.log('fetch players failed!')
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

const generateEndpoint = (endpoint: string, request: FetchPlayersRequest): string => {
  const { sport_category_id, name, country, dominant_arm, gender, backhand_style } = request
  let queryParams = ''

  if (name) {
    queryParams += `&name=${encodeURIComponent(name)}`
  }
  if (country) {
    queryParams += `&country=${encodeURIComponent(country)}`
  }
  if (dominant_arm) {
    queryParams += `&dominant_arm=${dominant_arm}`
  }
  if (gender) {
    queryParams += `&gender=${gender}`
  }
  if (backhand_style) {
    queryParams += `&backhand_style=${backhand_style}`
  }

  // Remove the leading '&' character
  queryParams = queryParams.slice(1)

  return `${endpoint}?sport_category_id=${sport_category_id}${queryParams ? `&${queryParams}` : ''}`
}

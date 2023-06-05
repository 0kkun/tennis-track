import axios, { AxiosError, AxiosInstance, AxiosRequestConfig, AxiosResponse } from 'axios'
import { checkAuth } from '@/hooks/useAuth'

export type ApiSuccessResponse = {
  status: number
  message: string
  data?: object
}

export type ApiErrorResponse = {
  status: number
  message: string
  data?: object
}

class ApiClient {
  private instance: AxiosInstance

  constructor() {
    this.instance = axios.create({
      baseURL: 'http://localhost:80',
      headers: {
        'Content-Type': 'application/json',
        Accept: 'application/json',
      },
      timeout: 10000,
      withCredentials: true,
    })

    this.instance.interceptors.request.use(
      (config) => {
        // Cookieからトークンを取得する
        const token = document.cookie.replace(
          /(?:(?:^|.*;\s*)access_token\s*=\s*([^;]*).*$)|^.*$/,
          '$1',
        )
        // トークンが存在する場合はAPIヘッダーにBearerトークンを設定する
        if (token) {
          config.headers.Authorization = `Bearer ${token}`
        }
        return config
      },
      (error) => {
        console.log(error)
        return Promise.reject(error)
      },
    )

    // axiosのresponseインターセプターを設定する
    this.instance.interceptors.response.use(
      (response: AxiosResponse) => {
        // APIから返却されたトークンをCookieに保存する
        if (response.data?.data) {
          if (!checkAuth()) {
            this.setAuthToken(response.data.data.token)
          }
        }
        return response
      },
      (error: AxiosError<ApiErrorResponse>) => {
        console.log(error)
        return Promise.reject(error)
      },
    )
  }

  public get(url: string, config?: AxiosRequestConfig): Promise<AxiosResponse> {
    return this.instance.get(url, config)
  }

  public post(url: string, data?: any, config?: AxiosRequestConfig): Promise<AxiosResponse> {
    return this.instance.post(url, data, config)
  }

  public patch(url: string, data?: any, config?: AxiosRequestConfig): Promise<AxiosResponse> {
    return this.instance.patch(url, data, config)
  }

  public delete(url: string, config?: AxiosRequestConfig): Promise<AxiosResponse> {
    return this.instance.delete(url, config)
  }

  /**
   * アクセストークンをcookieにセットする
   * @param token
   */
  private setAuthToken(token: string): void {
    if (token) {
      const expires = new Date()
      expires.setDate(expires.getDate() + 7)
      // Cookieにトークンを保存する
      document.cookie = `access_token=${token}; expires=${expires.toUTCString()}; path=/`
      console.log('Complete set access_token to cookie')
    } else {
      console.log('access_token delete')
      // Cookieからトークンを削除する
      document.cookie = 'access_token=; expires=Thu, 01 Jan 1970 00:00:01 GMT;'
    }
  }

  unsetAuthToken(): void {
    this.setAuthToken('')
    console.log('Delete access_token.')
  }
}

export default new ApiClient()

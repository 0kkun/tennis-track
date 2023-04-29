/**
 * axios関連
 */

import axios from 'axios'

export const axiosConfig = () => {
  axios.create({
    // APIのベースURL
    baseURL: 'http://localhost:80',
    headers: {
      'Content-Type': 'application/json',
      Accept: 'application/json',
    },
    timeout: 10000, // タイムアウト時間
  })
}

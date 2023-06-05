import { useState, useEffect } from 'react'

export const useAuth = () => {
  const [isLoggedIn, setIsLoggedIn] = useState(false)

  useEffect(() => {
    // ログイン状態のチェック
    const isLoggedIn = checkAuth()
    setIsLoggedIn(isLoggedIn)
  }, [])

  return [isLoggedIn, setIsLoggedIn]
}

// ログインしている場合はtrue、そうでない場合はfalseを返す
export function checkAuth(): boolean {
  const token = document.cookie.replace(/(?:(?:^|.*;\s*)access_token\s*=\s*([^;]*).*$)|^.*$/, '$1')
  return Boolean(token)
}

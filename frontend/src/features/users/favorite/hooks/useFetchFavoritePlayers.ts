import { useState } from 'react'
import { sendFetchFavoritePlayers } from '../apis/FavoritePlayerApi'
import { FavoritePlayers } from '../types/FavoritePlayer'

export const useFetchFavoritePlayers = () => {
  const [favoritePlayers, setFavoritePlayers] = useState<FavoritePlayers>([])

  const fetchFavoritePlayers = async () => {
    let response
    try {
      response = await sendFetchFavoritePlayers()
      if (response.status === 200) {
        console.log(response)
        // レスポンスデータを状態として更新
        setFavoritePlayers(response.data as FavoritePlayers)
      }
      return response
    } catch (e) {
      console.log(e)
    }
  }
  return {
    fetchFavoritePlayers,
    favoritePlayers,
    setFavoritePlayers,
  }
}

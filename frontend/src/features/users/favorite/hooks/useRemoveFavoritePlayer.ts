import { sendRemoveFavoritePlayer } from '../apis/FavoritePlayerApi'

export const useRemoveFavoritePlayer = () => {
  const removeFavoritePlayer = async (playerId: number) => {
    let response
    try {
      response = await sendRemoveFavoritePlayer({ player_id: playerId })
      if (response.status === 200) {
        console.log(response)
      }
      return response
    } catch (e) {
      console.log(e)
    }
  }
  return {
    removeFavoritePlayer,
  }
}

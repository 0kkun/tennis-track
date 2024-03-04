import { sendAddFavoritePlayer } from '../apis/FavoritePlayerApi'

export const useAddFavoritePlayer = () => {
  const addFavoritePlayer = async (playerId: number) => {
    let response
    try {
      response = await sendAddFavoritePlayer({ player_id: playerId })
      if (response.status === 200) {
        console.log(response)
      }
      return response
    } catch (e) {
      console.log(e)
    }
  }
  return {
    addFavoritePlayer,
  }
}

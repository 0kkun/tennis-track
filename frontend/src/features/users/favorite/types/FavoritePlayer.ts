export type AddFavoritePlayerRequest = {
  player_id: number
}

export type DestroyFavoritePlayerRequest = {
  player_id: number
}

export type FavoritePlayer = {
  id: number
  player_id: number
  name_en: string
}

export type FavoritePlayers = FavoritePlayer[]

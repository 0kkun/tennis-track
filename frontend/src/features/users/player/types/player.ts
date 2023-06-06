export type FetchPlayersRequest = {
  sport_category_id: number
  name?: string
  country?: string
  dominant_arm?: number
  gender?: number
  backhand_style?: number
}

export type Player = {
  id: number
  name_jp?: string
  name_en: string
  birthday?: string
  age?: string
  country?: string
  gender?: string
  backhand_style?: string
  dominant_arm?: string
  sport_category: string
}

export type Players = Player[]

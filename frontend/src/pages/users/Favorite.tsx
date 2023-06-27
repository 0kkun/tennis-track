import Sidebar from '@/components/layouts/Sidebar'
import { FC, useState, useEffect } from 'react'
import { PlayerTable } from '@/features/users/player/components/PlayerTable'
import { PlayerSearchBox } from '@/features/users/player/components/PlayerSearchBox'
import { FavoritePlayerTable } from '@/features/users/favorite/components/FavoritePlayerTable'
import { useFetchPlayers } from '@/features/users/player/hooks/useFetchPlayers'
import { useFetchFavoritePlayers } from '@/features/users/favorite/hooks/useFetchFavoritePlayers'
import { useAddFavoritePlayer } from '@/features/users/favorite/hooks/useAddFavoritePlayer'
import { useRemoveFavoritePlayer } from '@/features/users/favorite/hooks/useRemoveFavoritePlayer'
import { Players } from '@/features/users/player/types/player'
import Typography from '@mui/material/Typography'
import CircularProgress from '@mui/material/CircularProgress'
import { FavoritePlayers } from '@/features/users/favorite/types/FavoritePlayer'

export const Favorite: FC = () => {
  const { fetchPlayers, players, register, setPlayers } = useFetchPlayers()
  const { fetchFavoritePlayers, favoritePlayers, setFavoritePlayers } = useFetchFavoritePlayers()
  const { addFavoritePlayer } = useAddFavoritePlayer()
  const { removeFavoritePlayer } = useRemoveFavoritePlayer()
  const [isLoading, setIsLoading] = useState<boolean>(true)

  // 初回遷移時に表示するデータ
  useEffect(() => {
    const fetchInitialData = async () => {
      try {
        const playersRes = await fetchPlayers()
        const favoritePlayerRes = await fetchFavoritePlayers()

        if (
          playersRes &&
          favoritePlayerRes &&
          playersRes.status === 200 &&
          favoritePlayerRes.status === 200
        ) {
          setPlayers(playersRes.data as Players)
          setFavoritePlayers(favoritePlayerRes.data as FavoritePlayers)
          setIsLoading(false)
        }
      } catch (error) {
        console.log(error)
      }
    }
    fetchInitialData()
  }, [])

  const handleAddFavoritePlayer = async (playerId: number) => {
    await addFavoritePlayer(playerId)
    const favoritePlayerRes = await fetchFavoritePlayers()
    if (favoritePlayerRes) {
      setFavoritePlayers(favoritePlayerRes.data as FavoritePlayers)
    }
  }

  const handleRemoveFavoritePlayer = async (playerId: number) => {
    await removeFavoritePlayer(playerId)
    const favoritePlayerRes = await fetchFavoritePlayers()
    if (favoritePlayerRes) {
      setFavoritePlayers(favoritePlayerRes.data as FavoritePlayers)
    }
  }

  return (
    <div className="layer-1 flex h-screen bg-gray-100">
      <Sidebar />
      <div className="flex-1 p-10">
        <Typography variant="h3" component="h1" color="textPrimary">
          Favorite
        </Typography>
        <PlayerSearchBox fetchPlayers={fetchPlayers} register={register} />
        {isLoading && (
          <div className="min-h-200px flex items-center justify-center">
            <CircularProgress size={30} color="secondary" />
          </div>
        )}
        {!isLoading && (
          <div className="flex">
            <div className="flex-1 pr-5">
              <FavoritePlayerTable
                removeFavoritePlayer={handleRemoveFavoritePlayer}
                favoritePlayers={favoritePlayers}
              />
            </div>
            <div className="flex-2">
              <PlayerTable addFavoritePlayer={handleAddFavoritePlayer} players={players} />
            </div>
          </div>
        )}
      </div>
    </div>
  )
}

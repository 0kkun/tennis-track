import Sidebar from '@/components/layouts/Sidebar'
import { FC, useState, useEffect } from 'react'
import { PlayerTable } from '@/features/users/player/components/PlayerTable'
import { PlayerSearchBox } from '@/features/users/player/components/PlayerSearchBox'
import { useFetchPlayers } from '@/features/users/player/hooks/useFetchPlayers'
import { Players } from '@/features/users/player/types/player'

export const Favorite: FC = () => {
  const { fetchPlayers, players, register } = useFetchPlayers()

  const [initPlayers, setInitPlayers] = useState<Players>([])

  const [isLoading, setIsLoading] = useState<boolean>(true)

  // 初回遷移時に表示するデータ
  useEffect(() => {
    const fetchInitialData = async () => {
      try {
        const response = await fetchPlayers()
        if (response && response.status === 200) {
          setInitPlayers(response.data as Players)
          setIsLoading(false)
        }
      } catch (error) {
        console.log(error)
      }
    }
    fetchInitialData()
  }, [])

  return (
    <div className="layer-1 flex h-screen bg-gray-100">
      <Sidebar />
      <div className="flex-1 p-10">
        <h1 className="font-semibol mb-5 text-xl">Favorite</h1>
        <PlayerSearchBox fetchPlayers={fetchPlayers} register={register} />
        <PlayerTable players={players.length > 0 ? players : initPlayers} isLoading={isLoading} />
      </div>
    </div>
  )
}

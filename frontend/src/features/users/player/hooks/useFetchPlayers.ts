import { useState } from 'react'
import { useForm } from 'react-hook-form'
import { sendFetchPlayers } from '../apis/playerApi'
import { FetchPlayersRequest, Players } from '../types/player'

interface ValidationErrors {
  [key: string]: string[] | ValidationErrors
}

export const useFetchPlayers = () => {
  const { register, getValues } = useForm()
  const [validationErrors, setValidationErrors] = useState<ValidationErrors>()
  const [players, setPlayers] = useState<Players>([])

  const fetchPlayers = async () => {
    let result
    const values = getValues()
    const request: FetchPlayersRequest = {
      sport_category_id: 1,
      name: values.name,
      country: values.country,
      dominant_arm: values.dominant_arm,
      gender: values.gender,
      backhand_style: values.backhand_style,
    }
    try {
      result = await sendFetchPlayers(request)
      if (result.status === 200) {
        console.log(result)
        // レスポンスデータを状態として更新
        setPlayers(result.data as Players)
      }
      if (result.status === 422) {
        setValidationErrors(result.data as ValidationErrors)
      }
      return result
    } catch (e) {
      console.log(e)
    }
  }
  return {
    register,
    fetchPlayers,
    validationErrors,
    players,
    setPlayers,
  }
}

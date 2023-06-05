import { FC } from 'react'
import { BasicTextField } from '@/components/elements/Inputs/BasicTextField'
import { ExecuteButton } from '@/components/elements/Buttons/ExcuteButton'
import { UseFormRegister } from 'react-hook-form'

interface PlayerSearchBoxProps {
  fetchPlayers: () => void
  register: UseFormRegister<any>
}

export const PlayerSearchBox: FC<PlayerSearchBoxProps> = ({ fetchPlayers, register }) => {
  return (
    <div className="mb-3 rounded bg-white p-3 shadow-md">
      <div className="flex gap-4">
        <div className="w-1/2">
          <BasicTextField title="name" placeholder="name" register={register('name')} />
        </div>
        <div className="w-1/2">
          <BasicTextField title="country" placeholder="country" register={register('country')} />
        </div>
        <div className="w-1/2">
          <BasicTextField
            title="dominant arm"
            placeholder="dominant arm"
            register={register('dominant_arm')}
          />
        </div>
        <div className="w-1/2">
          <BasicTextField title="gender" placeholder="gender" register={register('gender')} />
        </div>
        <div className="w-1/2">
          <BasicTextField
            title="backhand style"
            placeholder="backhand style"
            register={register('backhand_style')}
          />
        </div>
      </div>
      <div className="text-right">
        <ExecuteButton title="Search" onClick={fetchPlayers} />
      </div>
    </div>
  )
}

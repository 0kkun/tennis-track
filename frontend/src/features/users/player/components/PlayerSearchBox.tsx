import { FC } from 'react'
import { BasicTextField } from '@/components/elements/Inputs/BasicTextField'
import { UseFormRegister } from 'react-hook-form'
import { MuiButton } from '@/components/elements/Buttons/MuiButton'
import { BasicSelectBoxField } from '@/components/elements/Inputs/BasicSelectBoxField'

interface PlayerSearchBoxProps {
  fetchPlayers: () => void
  register: UseFormRegister<any>
}

export const PlayerSearchBox: FC<PlayerSearchBoxProps> = ({ fetchPlayers, register }) => {
  const backhandStyles = [
    { value: 0, label: '片手' },
    { value: 1, label: '両手' },
  ]
  const dominantArms = [
    { value: 0, label: '右' },
    { value: 1, label: '左' },
  ]
  const genders = [
    { value: 0, label: '男性' },
    { value: 1, label: '女性' },
  ]

  return (
    <div className="mb-3 rounded bg-white p-3 shadow-md">
      <div className="flex gap-4">
        <div className="w-1/2">
          <BasicTextField label="name" name="name" placeholder="name" register={register} />
        </div>
        <div className="w-1/2">
          <BasicTextField
            label="country"
            name="country"
            placeholder="country"
            register={register}
          />
        </div>
        <div className="w-1/2">
          <BasicSelectBoxField
            name="backhand_style"
            label="backhand style"
            selectItems={backhandStyles}
            register={register}
          />
        </div>
        <div className="w-1/2">
          <BasicSelectBoxField
            name="dominant_arm"
            label="dominant arm"
            selectItems={dominantArms}
            register={register}
          />
        </div>
        <div className="w-1/2">
          <BasicSelectBoxField
            name="gender"
            label="gender"
            selectItems={genders}
            register={register}
          />
        </div>
      </div>
      <div className="text-right">
        <MuiButton
          title="Search"
          variant="contained"
          style=""
          color="primary"
          onClick={() => fetchPlayers()}
        />
      </div>
    </div>
  )
}

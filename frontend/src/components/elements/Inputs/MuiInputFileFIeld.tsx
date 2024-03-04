import { FC, memo } from 'react'
import { Button, ButtonProps } from '@mui/material'
import { UseFormRegister, FieldValues } from 'react-hook-form'

type Props = {
  name: string
  title?: string
  register: UseFormRegister<FieldValues>
  style?: string
} & ButtonProps

export const BasicFileField: FC<Props> = memo(
  ({ name, title = 'ファイルを選択', register, style, ...buttonProps }) => {
    return (
      <>
        <input
          accept="image/*"
          className={`
            hidden
            ${style}
          `}
          id="file-input"
          type="file"
          {...register(name)}
        />
        <label htmlFor="file-input">
          <Button variant="contained" component="span" {...buttonProps}>
            {title}
          </Button>
        </label>
      </>
    )
  },
)

import { FC, memo, HTMLProps } from 'react'
import { Button, ButtonProps } from '@mui/material'

type Props = {
  title?: string
  register?: HTMLProps<HTMLInputElement>['ref']
  style?: string
} & ButtonProps

export const BasicFileField: FC<Props> = memo(
  ({ title = 'ファイルを選択', register, style, ...buttonProps }) => {
    return (
      <div>
        <input accept="image/*" className="hidden" id="file-input" type="file" ref={register} />
        <label htmlFor="file-input">
          <Button variant="contained" component="span" {...buttonProps}>
            {title}
          </Button>
        </label>
      </div>
    )
  },
)

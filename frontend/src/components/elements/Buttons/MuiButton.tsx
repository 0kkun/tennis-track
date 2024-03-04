import { FC, memo } from 'react'
import { Button, ButtonProps } from '@mui/material'

type Props = ButtonProps & {
  title: string
  style?: string
}

// ** ButtonProps Args **
// variant :
//      "text": テキストボタン。背景色は透明で、テキストのみ表示されます。
//      "outlined": アウトラインボタン。背景は透明で、境界線が表示されます。
//      "contained": コンテインドボタン。背景色が設定され、境界線が表示されません。
// color : 'default' | 'primary' | 'secondary' | 'success' | 'error' | 'warning' | 'info'
// onClick : method.

export const MuiButton: FC<Props> = memo(({ title, style, ...rest }) => {
  return (
    <Button className={style} {...rest}>
      {title}
    </Button>
  )
})

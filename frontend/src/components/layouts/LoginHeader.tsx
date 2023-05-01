import { FC, memo } from 'react'
import Logo from '@/components/elements/Icons/Logo'

export const LoginHeader: FC = memo(() => {
  return (
    <header className="h-[80px] w-[100%] bg-green-800 text-white">
      <h1>
        <Logo className="ml-[10px] mt-[15px] inline-block h-[50px] w-[auto] fill-current" />
      </h1>
    </header>
  )
})

LoginHeader.displayName = 'LoginHeader'

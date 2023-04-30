import { FC, memo } from 'react'
import Logo from '@/components/elements/Icons/Logo'

export const LoginHeader: FC = memo(() => {
  return (
    <header className="h-[80px] w-[100%] bg-green-800 text-white">
      <h1>
        <Logo className="inline-block h-[50px] w-[auto] fill-current mt-[15px] ml-[10px]" />
      </h1>
    </header>
  )
})

LoginHeader.displayName = 'LoginHeader'

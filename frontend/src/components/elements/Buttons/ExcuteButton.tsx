import { FC, memo } from 'react'

// styleでwidthや他のcssを調整する
type Props = {
  title: string
  style?: string
  onClick: () => void
}

export const ExecuteButton: FC<Props> = memo(({ title, style, onClick }) => {
  return (
    <button
      className={`
        rounded
        bg-green-500
        px-4
        py-2
        font-bold
        leading-4
        text-white
        drop-shadow-[0_0_8px_rgba(0,0,0,0.16)]
        hover:opacity-[.80]
        ${style}
      `}
      onClick={onClick}
    >
      {title}
    </button>
  )
})

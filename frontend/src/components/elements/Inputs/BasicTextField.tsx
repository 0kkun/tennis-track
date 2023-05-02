import { FC, memo, useState } from 'react'

type Props = {
  title: string
  placeholder: string
  register?: object
  style?: string
  password?: boolean
}

export const BasicTextField: FC<Props> = memo(
  ({ title, placeholder, register, style, password = false }) => {
    const [isPassword, setIsPassword] = useState<boolean>(password)
    const togglePassword = () => {
      if (isPassword) {
        setIsPassword(false)
      } else {
        setIsPassword(true)
      }
    }

    return (
      <div className={`mb-3 w-[100%] ${style}`}>
        <h3 className="mb-[6px] text-[16px] font-semibold">{title}</h3>
        <div className="">
          <input
            className="w-[100%] rounded border border-gray-400 p-2"
            placeholder={placeholder}
            type={isPassword ? 'password' : 'text'}
            {...register}
          />
          {password && (
            <button className="ml-[15px]" onClick={togglePassword}></button>
          )}
        </div>
      </div>
    )
  },
)

BasicTextField.displayName = 'BasicTextField'

import { FC, memo, useState } from 'react'
import { UseFormRegister, FieldValues } from 'react-hook-form'

type Props = {
  name: string
  label: string
  placeholder: string
  register: UseFormRegister<FieldValues>
  style?: string
  password?: boolean
}

export const BasicTextField: FC<Props> = memo(
  ({ name, label, placeholder, register, style, password = false }) => {
    const [isPassword, setIsPassword] = useState<boolean>(password)
    const togglePassword = () => {
      if (isPassword) {
        setIsPassword(false)
      } else {
        setIsPassword(true)
      }
    }
    return (
      <>
        <div className={`mb-3 min-w-[150px]`}>
          <label
            htmlFor={`input-form-${name}`}
            className="mb-2 block text-sm font-medium text-gray-900 dark:text-white"
          >
            {label}
          </label>
          <input
            id={`input-form-${name}`}
            className="w-[100%] rounded border border-gray-400 p-2"
            placeholder={placeholder}
            type={isPassword ? 'password' : 'text'}
            {...register(name)}
          />
          {password && <button className="ml-[15px]" onClick={togglePassword}></button>}
        </div>
      </>
    )
  },
)

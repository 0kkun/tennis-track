import { FC, memo } from 'react'
import { UseFormRegister, FieldValues } from 'react-hook-form'

type SelectItem = {
  label: string
  value: number | string
}

type Props = {
  label: string
  name: string
  register: UseFormRegister<FieldValues>
  style?: string
  selectItems: SelectItem[]
}

export const BasicSelectBoxField: FC<Props> = memo(
  ({ label, name, register, style, selectItems }) => {
    return (
      <>
        <div className="mb-3 min-w-[150px]">
          <label
            htmlFor={`input-form-${name}`}
            className="mb-2 block text-sm font-medium text-gray-900 dark:text-white"
          >
            {label}
          </label>
          <select
            id={`input-form-${name}`}
            className={`block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500 ${style}`}
            {...register(name)}
          >
            <option value="" selected>
              未選択
            </option>
            {selectItems.map((item, index) => (
              <option key={index} value={item.value}>
                {item.label}
              </option>
            ))}
            <option value=""></option>
          </select>
        </div>
      </>
    )
  },
)

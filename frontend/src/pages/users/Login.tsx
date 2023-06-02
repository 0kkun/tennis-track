import { LoginHeader } from '@/components/layouts/LoginHeader'
import { Link } from 'react-router-dom'
import { useLogin } from '@/features/users/login/hooks/useLogin'
import { BasicTextField } from '@/components/elements/Inputs/BasicTextField'
import { ExecuteButton } from '@/components/elements/Buttons/ExcuteButton'

export const Login = () => {
  const login = useLogin()
  const validError = login.validationErrors

  const validationErrorContent = () => {
    if (validError !== undefined && typeof validError === 'object') {
      return Object.keys(validError).map((key) => (
        <ul key={key}>
          {(validError[key] as string[]).map((error) => (
            <li key={error}>・{error}</li>
          ))}
        </ul>
      ))
    } else {
      return null
    }
  }

  return (
    <div className="layer-1 h-screen bg-gray-100">
      <LoginHeader />
      <div className="ml-[auto] mr-[auto] mt-[80px] w-1/3 rounded-md border bg-white p-[50px] shadow-md">
        <div className="pb-3 text-red-500">{validationErrorContent()}</div>
        <BasicTextField
          title="ログインID (メールアドレス)"
          placeholder="メールアドレス"
          register={login.register('email')}
        />
        <BasicTextField
          title="パスワード"
          placeholder="パスワード"
          password
          register={login.register('password')}
        />
        <div className="text-center">
          <ExecuteButton title="ログイン" style="w-1/2" onClick={login.login} />
        </div>
        <div className="mt-[15px] text-center">
          <Link to="/" className="mt-2 text-gray-500">
            ホーム画面に戻る
          </Link>
        </div>
      </div>
    </div>
  )
}

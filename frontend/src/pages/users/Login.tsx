import { LoginHeader } from '@/components/layouts/LoginHeader'
import { Link } from 'react-router-dom'
import { useLogin } from '@/features/login/hooks/useLogin'
import { BasicTextField } from '@/components/elements/Inputs/BasicTextField'
import { ExecuteButton } from '@/components/elements/Buttons/ExcuteButton'

export const Login = () => {
  const login = useLogin()

  return (
    <div className="layer-1 h-screen bg-gray-100">
      <LoginHeader />
      <div className="ml-[auto] mr-[auto] mt-[80px] w-1/3 rounded-md border bg-white p-[50px] shadow-md">
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

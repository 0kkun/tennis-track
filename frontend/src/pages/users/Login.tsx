import { LoginHeader } from '@/components/layouts/LoginHeader'
import { useState } from 'react'
import { Link, useNavigate } from 'react-router-dom'

export const Login = () => {
  const [username, setUsername] = useState('')
  const [password, setPassword] = useState('')
  const [isLoading, setIsLoading] = useState(false)
  const navigate = useNavigate()

  const handleSubmit = async (event: React.FormEvent<HTMLFormElement>) => {
    event.preventDefault()
    setIsLoading(true)

    // ここでログイン処理を実行
    // ここではダミーのログイン処理を実装
    if (username === 'admin' && password === 'password') {
      navigate('/')
    }

    setIsLoading(false)
  }

  return (
    <div className="h-screen bg-gray-100">
      <LoginHeader />
      <div className="w-1/3 bg-white rounded-md ml-[auto] mr-[auto] mt-[80px] p-[50px] border shadow-md">
        <form onSubmit={handleSubmit} className="flex flex-col space-y-4">
          <div className="flex flex-col w-[100%]">
            <label htmlFor="username" className="font-semibold">
              ログインID (メールアドレス)
            </label>
            <input
              type="text"
              id="username"
              className="border border-gray-400 p-2 rounded"
              placeholder="メールアドレス"
              value={username}
              onChange={(e) => setUsername(e.target.value)}
            />
          </div>
          <div className="flex flex-col">
            <label htmlFor="password" className="font-semibold">
              パスワード
            </label>
            <input
              type="password"
              id="password"
              className="border border-gray-400 p-2 rounded"
              placeholder="パスワード"
              value={password}
              onChange={(e) => setPassword(e.target.value)}
            />
          </div>
          <div className="text-center">
            <button
              className={`w-1/2 ${
                isLoading ? 'bg-gray-400 cursor-not-allowed' : 'bg-green-500'
              } text-white px-4 py-2 rounded`}
              disabled={isLoading}
              type="submit"
            >
              {isLoading ? 'ログイン中...' : 'ログイン'}
            </button>
            
          </div>
        </form>
        <div className="text-center mt-[15px]">
          <Link to="/" className="text-gray-500 mt-2">
            ホーム画面に戻る
          </Link>
        </div>
      </div>
    </div>
  )
}
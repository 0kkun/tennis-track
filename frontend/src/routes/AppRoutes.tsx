import { Route, Routes } from 'react-router-dom'
import { Home } from '@/pages/users/Home'
import { Login } from '@/pages/users/Login'
import { useAuth } from '@/hooks/useAuth'

const AuthGuard = ({ children }: { children: React.ReactNode }) => {
  const [isLoggedIn] = useAuth()
  if (!isLoggedIn) {
    return null
  }
  return <>{children}</>
}

export const AppRoutes = () => {
  return (
    <Routes>
      <Route path="/login" element={<Login />} />
      <Route path="/" element={<AuthGuard><Home /></AuthGuard>} />
    </Routes>
  )
}

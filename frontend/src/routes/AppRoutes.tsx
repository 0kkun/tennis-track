import { Route, Routes, useNavigate } from 'react-router-dom'
import { Home } from '@/pages/users/Home'
import { Login } from '@/pages/users/Login'
import { Favorite } from '@/pages/users/Favorite'
import { useAuth } from '@/hooks/useAuth'

const AuthGuard = ({ children }: { children: React.ReactNode }) => {
  const [isLoggedIn] = useAuth()
  const navigate = useNavigate()

  if (!isLoggedIn) {
    navigate('/login', { replace: true })
    return null
  }
  return <>{children}</>
}

export const AppRoutes = () => {
  return (
    <Routes>
      <Route path="/login" element={<Login />} />
      <Route
        path="/"
        element={
          <AuthGuard>
            <Home />
          </AuthGuard>
        }
      />
      <Route
        path="/favorite"
        element={
          <AuthGuard>
            <Favorite />
          </AuthGuard>
        }
      />
    </Routes>
  )
}

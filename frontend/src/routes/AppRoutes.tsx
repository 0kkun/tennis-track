import { Route, Routes } from 'react-router-dom'
import { Home } from '@/pages/users/Home'
import { Login } from '@/pages/users/Login'
import { Favorite } from '@/pages/users/Favorite'
// import { useAuth } from '@/hooks/useAuth'

// const AuthGuard = ({ children }: { children: React.ReactNode }) => {
//   const [isLoggedIn] = useAuth()
//   const navigate = useNavigate()

//   if (!isLoggedIn) {
//     navigate('/login', { replace: true })
//     return null
//   }
//   return <>{children}</>
// }

export const AppRoutes = () => {
  return (
    <Routes>
      <Route path="/login" element={<Login />} />
      <Route path="/" element={<Home />} />
      <Route path="/favorite" element={<Favorite />} />
    </Routes>
  )
}

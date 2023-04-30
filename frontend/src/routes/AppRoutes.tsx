import { Route, Routes } from 'react-router-dom'
import { Home } from '@/pages/users/Home'
import { Login } from '@/pages/users/Login'

export const AppRoutes = () => {
  return (
    <Routes>
      <Route path="/" element={<Home />}></Route>
      <Route path="/login" element={<Login />} />
    </Routes>
  )
}

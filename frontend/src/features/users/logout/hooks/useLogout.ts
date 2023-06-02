import { sendLogout } from '../apis/LogoutApi'
import { useNavigate } from 'react-router-dom'

export const useLogout = () => {
  const navigate = useNavigate()
  const logout = async () => {
    try {
      await sendLogout()
      navigate('/login')
    } catch (e) {
      console.log(e)
    }
  }
  return {
    logout,
  }
}

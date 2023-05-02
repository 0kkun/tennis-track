import { useForm } from 'react-hook-form'
import { sendLogin } from '../apis/LoginApi'
import { LoginRequest } from '../types/login'
import { useNavigate } from 'react-router-dom'

export const useLogin = () => {
  const { register, getValues } = useForm()
  const navigate = useNavigate()

  const login = async () => {
    const values = getValues()
    const request: LoginRequest = {
      email: values.email,
      password: values.password,
    }
    try {
      await sendLogin(request)
      navigate('/')
    } catch (e) {
      console.log(e)
    }
  }
  return {
    register,
    login,
  }
}

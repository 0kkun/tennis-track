import { useState } from 'react'
import { useForm } from 'react-hook-form'
import { sendLogin } from '../apis/LoginApi'
import { LoginRequest } from '../types/login'
import { useNavigate } from 'react-router-dom'

interface ValidationErrors {
  [key: string]: string[] | ValidationErrors
}

export const useLogin = () => {
  const { register, getValues } = useForm()
  const [validationErrors, setValidationErrors] = useState<ValidationErrors>()
  const navigate = useNavigate()

  const login = async () => {
    let result
    const values = getValues()
    const request: LoginRequest = {
      email: values.email,
      password: values.password,
    }
    try {
      result = await sendLogin(request)
      if (result.status === 200) {
        console.log('Login successful')
        navigate('/')
      }
      if (result.status === 422) {
        setValidationErrors(result.data as ValidationErrors)
      }
      return result
    } catch (e) {
      console.log(e)
    }
  }
  return {
    register,
    login,
    validationErrors,
  }
}

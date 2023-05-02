import * as React from 'react'
import { BrowserRouter } from 'react-router-dom'
import { ErrorBoundary } from 'react-error-boundary'
import apiClient from '@/libs/apiClient'

const ErrorFallback = () => {
  return (
    <div
      className="flex h-screen w-screen flex-col items-center justify-center text-red-500"
      role="alert"
    >
      <h2 className="text-lg font-semibold">エラーが発生しました。</h2>
      <button
        className="mt-4"
        onClick={() => window.location.assign(window.location.origin)}
      >
        Refresh
      </button>
    </div>
  )
}

type AppProviderProps = {
  children: React.ReactElement
}

export const AppProvider = ({ children }: AppProviderProps) => {
  React.useEffect(() => {
    apiClient
  }, [])

  return (
    <ErrorBoundary FallbackComponent={ErrorFallback}>
      <BrowserRouter>{children}</BrowserRouter>
    </ErrorBoundary>
  )
}

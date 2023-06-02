import React, { useState } from 'react'
import Logo from '@/components/elements/Icons/Logo'
import { Link, useLocation } from 'react-router-dom'
import {
  HomeIcon,
  CogIcon,
  NewspaperIcon,
  VideoCameraIcon,
  HeartIcon,
  MenuAlt1Icon,
  FireIcon,
  LogoutIcon,
} from '@heroicons/react/solid'
import { useLogout } from '@/features/users/logout/hooks/useLogout'

function Sidebar() {
  // サイドバーの開閉
  const [isMenuOpen, setIsMenuOpen] = useState(true)
  // 現在のパス名を取得
  const location = useLocation()

  const logout = useLogout()

  const handleMenuClick = () => {
    setIsMenuOpen(!isMenuOpen)
  }

  return (
    <div
      className={`mb-[8px] ml-[8px] mt-[8px] w-[80px] rounded-md border-r bg-green-800 px-3 py-3 text-center text-white ${
        isMenuOpen ? '' : 'h-[55px]'
      }`}
    >
      <button className="mb-3 md:hidden" onClick={handleMenuClick}>
        <MenuAlt1Icon className="inline-block h-[32px] w-[32px] fill-current" />
      </button>
      <div className={`${isMenuOpen ? 'block' : 'hidden'}`}>
        <div className="mb-3 text-center">
          <Logo className="inline-block h-[32px] w-[32px] fill-current" />
        </div>
        <div className="space-y-[13px] text-sm">
          <div
            className={`w-[100%] text-center ${
              location.pathname === '/' ? 'rounded-md bg-white text-black' : ''
            }`}
          >
            <Link to="/" className="hover:text-gray-400">
              <HomeIcon className="inline-block h-[32px] w-[32px]" />
              <p>Home</p>
            </Link>
          </div>
          <div
            className={`w-[100%] text-center ${
              location.pathname === '/news' ? 'rounded-md bg-white text-black' : ''
            }`}
          >
            <Link to="/" className="hover:text-gray-400">
              <NewspaperIcon className="inline-block h-[32px] w-[32px]" />
              <p>News</p>
            </Link>
          </div>
          <div
            className={`w-[100%] text-center ${
              location.pathname === '/movies' ? 'rounded-md bg-white text-black' : ''
            }`}
          >
            <Link to="/" className="hover:text-gray-400">
              <VideoCameraIcon className="inline-block h-[32px] w-[32px]" />
              <p>Movie</p>
            </Link>
          </div>
          <div
            className={`w-[100%] text-center ${
              location.pathname === '/rankings' ? 'rounded-md bg-white text-black' : ''
            }`}
          >
            <Link to="/" className="hover:text-gray-400">
              <FireIcon className="inline-block h-[32px] w-[32px]" />
              <p>Ranking</p>
            </Link>
          </div>
          <div
            className={`w-[100%] text-center ${
              location.pathname === '/favorites' ? 'rounded-md bg-white text-black' : ''
            }`}
          >
            <Link to="/" className="hover:text-gray-400">
              <HeartIcon className="inline-block h-[32px] w-[32px]" />
              <p>Favorite</p>
            </Link>
          </div>
          <div
            className={`w-[100%] text-center ${
              location.pathname === '/settings' ? 'rounded-md bg-white text-black' : ''
            }`}
          >
            <Link to="/" className="hover:text-gray-400">
              <CogIcon className="inline-block h-[32px] w-[32px]" />
              <p>Setting</p>
            </Link>
          </div>
          <button className="hover:text-gray-400" onClick={logout.logout}>
            <LogoutIcon className="inline-block h-[32px] w-[32px]" />
            <p>Logout</p>
          </button>
        </div>
      </div>
    </div>
  )
}

export default Sidebar

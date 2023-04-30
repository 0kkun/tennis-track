import React, { useState } from 'react'
import Logo from '@/components/elements/Icons/Logo'
import { Link, useLocation } from 'react-router-dom'
import { HomeIcon, CogIcon, NewspaperIcon, VideoCameraIcon, HeartIcon, MenuAlt1Icon, FireIcon } from '@heroicons/react/solid'

function Sidebar() {
  // サイドバーの開閉
  const [isMenuOpen, setIsMenuOpen] = useState(true)
  // 現在のパス名を取得
  const location = useLocation()

  const handleMenuClick = () => {
    setIsMenuOpen(!isMenuOpen)
  }

  return (
    <div className={`bg-green-800 text-white text-center w-[80px] px-3 py-3 border-r mt-[8px] mb-[8px] ml-[8px] rounded-md ${isMenuOpen ? '' : 'h-[55px]'}`}>
      <button className="md:hidden mb-3" onClick={handleMenuClick}>
        <MenuAlt1Icon className="w-[32px] h-[32px] fill-current inline-block" />
      </button>
      <div className={`${isMenuOpen ? 'block' : 'hidden'}`}>
        <div className="mb-3 text-center">
          <Logo className="w-[32px] h-[32px] fill-current inline-block" />
        </div>
        <div className="text-sm space-y-[13px]">
          <div className={`w-[100%] text-center ${location.pathname === '/' ? 'bg-white rounded-md text-black' : ''}`}>
            <Link to="/" className="hover:text-gray-400">
              <HomeIcon className="w-[32px] h-[32px] inline-block" />
              <p>Home</p>
            </Link>
          </div>
          <div className={`w-[100%] text-center ${location.pathname === '/news' ? 'bg-white rounded-md text-black' : ''}`}>
            <Link to="/" className="hover:text-gray-400">
              <NewspaperIcon className="w-[32px] h-[32px] inline-block" />
              <p>News</p>
            </Link>
          </div>
          <div className={`w-[100%] text-center ${location.pathname === '/movies' ? 'bg-white rounded-md text-black' : ''}`}>
            <Link to="/" className="hover:text-gray-400">
              <VideoCameraIcon className="w-[32px] h-[32px] inline-block" />
              <p>Movie</p>
            </Link>
          </div>
          <div className={`w-[100%] text-center ${location.pathname === '/rankings' ? 'bg-white rounded-md text-black' : ''}`}>
            <Link to="/" className="hover:text-gray-400">
              <FireIcon className="w-[32px] h-[32px] inline-block" />
              <p>Ranking</p>
            </Link>
          </div>
          <div className={`w-[100%] text-center ${location.pathname === '/favorites' ? 'bg-white rounded-md text-black' : ''}`}>
            <Link to="/" className="hover:text-gray-400">
              <HeartIcon className="w-[32px] h-[32px] inline-block" />
              <p>Favorite</p>
            </Link>
          </div>
          <div className={`w-[100%] text-center ${location.pathname === '/settings' ? 'bg-white rounded-md text-black' : ''}`}>
            <Link to="/" className="hover:text-gray-400">
              <CogIcon className="w-[32px] h-[32px] inline-block" />
              <p>Setting</p>
            </Link>
          </div>
        </div>
      </div>
    </div>
  )
}

export default Sidebar

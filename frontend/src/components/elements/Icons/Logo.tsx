import React, { SVGProps } from 'react'

interface LogoProps extends SVGProps<SVGSVGElement> {
  className?: string
}

const Logo = ({ className }: LogoProps) => (
  <svg
    className={className}
    xmlns="http://www.w3.org/2000/svg"
    viewBox="0 0 32 32"
    width="32"
    height="32"
    fill="#FBBF24"
    shapeRendering="geometricPrecision"
    style={{ borderRadius: '50%', background: '#FBBF24' }}
  >
    <text
      x="50%"
      y="50%"
      textAnchor="middle"
      fontSize="9"
      fontWeight="bold"
      fontFamily="sans-serif"
      dy="-1"
    >
      Tennis
      <tspan x="50%" dy="1.2em">
        Track
      </tspan>
    </text>
  </svg>
)

export default Logo

type LogoProps = {
  className?: string
}

export function Logo({ className = '' }: LogoProps) {
  return (
    <a href="#inicio" className={`logo ${className}`.trim()} aria-label="Facilita Capital">
      <svg className="logo-mark" viewBox="0 0 80 70" aria-hidden="true">
        <path
          className="logo-shadow"
          d="M16 34.5 68 12.5 38 41 29 60Z"
          fill="currentColor"
        />
        <path d="M14 32.5 66 10.5 36 39Z" fill="#ffffff" />
        <path
          className="logo-stroke"
          d="M14 32.5 66 10.5 36 39Z"
          fill="none"
          strokeWidth="2.6"
          strokeLinejoin="round"
          strokeLinecap="round"
        />
        <path
          className="logo-stroke"
          d="M36 39 66 10.5 27 58Z"
          fill="none"
          strokeWidth="2.6"
          strokeLinejoin="round"
          strokeLinecap="round"
        />
        <path
          className="logo-stroke"
          d="M14 32.5 36 39 27 58"
          fill="none"
          strokeWidth="2.6"
          strokeLinejoin="round"
          strokeLinecap="round"
        />
        <g className="logo-stroke" strokeWidth="2.4" strokeLinecap="round" fill="none">
          <path d="M6 37.5 16 33.2" />
          <path d="M7.2 44 18.5 38.4" />
          <path d="M9.5 50.5 19.8 45.2" />
        </g>
      </svg>
      <span className="logo-word">
        <span className="logo-facilita">Facilita</span>
        <span className="logo-capital">Capital</span>
      </span>
    </a>
  )
}

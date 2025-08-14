export interface User {
  name: string
  email: string
  profile_photo_url: string | null

  email_verified_at: string | null
  two_factor_enabled: boolean
  two_factor_confirmed: boolean
}

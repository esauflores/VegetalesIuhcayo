import { Link } from 'src/assets/models/link'

export interface Page {
  title: string
  tabs: Link[] | null
}

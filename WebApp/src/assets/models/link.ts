export interface Link {
  title: string
  icon: string
  route: string | null
  sublinks: Link[] | null
}

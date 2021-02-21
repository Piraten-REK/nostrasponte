export const breakPoints = [768, 1366]

export const mediaSm = () => {
  return window.innerWidth < breakPoints[0]
}

export const mediaMd = () => {
  return window.innerWidth >= breakPoints[0]
}

export const mediaLg = () => {
  return window.innerWidth >= breakPoints[1]
}

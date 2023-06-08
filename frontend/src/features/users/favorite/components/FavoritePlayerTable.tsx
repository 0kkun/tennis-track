import { FC } from 'react'
import {
  Table,
  TableBody,
  TableCell,
  TableContainer,
  TableHead,
  TableRow,
  Paper,
} from '@mui/material'
import { MuiButton } from '@/components/elements/Buttons/MuiButton'
import Typography from '@mui/material/Typography'
import { FavoritePlayers } from '../types/FavoritePlayer'

interface FavoritePlayerTableProps {
  removeFavoritePlayer: (id: number) => void
  favoritePlayers: FavoritePlayers
}

export const FavoritePlayerTable: FC<FavoritePlayerTableProps> = ({
  removeFavoritePlayer,
  favoritePlayers,
}) => {
  return (
    <section>
      <Typography variant="h5" component="h2" color="textPrimary">
        My Favorite Player
      </Typography>
      <TableContainer component={Paper} style={{ maxHeight: '65vh' }}>
        <Table stickyHeader>
          <TableHead>
            <TableRow>
              <TableCell>Name</TableCell>
              <TableCell></TableCell>
            </TableRow>
          </TableHead>
          <TableBody>
            {favoritePlayers.map((favoritePlayer) => (
              <TableRow key={favoritePlayer.id}>
                <TableCell>{favoritePlayer.name_en}</TableCell>
                <TableCell>
                  <div className="text-center">
                    <MuiButton
                      title="Remove"
                      style=""
                      color="error"
                      variant="contained"
                      onClick={() => removeFavoritePlayer(favoritePlayer.id)}
                    />
                  </div>
                </TableCell>
              </TableRow>
            ))}
          </TableBody>
        </Table>
      </TableContainer>
    </section>
  )
}

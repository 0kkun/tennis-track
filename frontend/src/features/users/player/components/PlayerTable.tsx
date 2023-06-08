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
import { Players } from '../types/player'
import { MuiButton } from '@/components/elements/Buttons/MuiButton'
import Typography from '@mui/material/Typography'

interface PlayerTableProps {
  addFavoritePlayer: (id: number) => void
  players: Players
}

export const PlayerTable: FC<PlayerTableProps> = ({ addFavoritePlayer, players }) => {
  return (
    <section>
      <Typography variant="h5" component="h2" color="">
        Player List
      </Typography>
      <TableContainer component={Paper} style={{ maxHeight: '65vh' }}>
        <Table stickyHeader>
          <TableHead>
            <TableRow>
              <TableCell>Name</TableCell>
              <TableCell>Birthday</TableCell>
              <TableCell>Age</TableCell>
              <TableCell>Country</TableCell>
              <TableCell>Gender</TableCell>
              <TableCell>Backhand Style</TableCell>
              <TableCell>Dominant Arm</TableCell>
              <TableCell>Sport Category</TableCell>
              <TableCell></TableCell>
            </TableRow>
          </TableHead>
          <TableBody>
            {players.map((player) => (
              <TableRow key={player.id}>
                <TableCell>{player.name_en}</TableCell>
                <TableCell>{player.birthday}</TableCell>
                <TableCell>{player.age}</TableCell>
                <TableCell>{player.country}</TableCell>
                <TableCell>{player.gender}</TableCell>
                <TableCell>{player.backhand_style}</TableCell>
                <TableCell>{player.dominant_arm}</TableCell>
                <TableCell>{player.sport_category}</TableCell>
                <TableCell>
                  <div className="text-center">
                    <MuiButton
                      title="Add"
                      style=""
                      color="success"
                      variant="contained"
                      onClick={() => addFavoritePlayer(player.id)}
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

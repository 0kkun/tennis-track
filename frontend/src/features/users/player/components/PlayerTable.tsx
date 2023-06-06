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
import CircularProgress from '@mui/material/CircularProgress'
import { MuiButton } from '@/components/elements/Buttons/MuiButton'
import Typography from '@mui/material/Typography'

interface PlayerTableProps {
  players: Players
  isLoading: boolean
}

export const PlayerTable: FC<PlayerTableProps> = ({ players, isLoading }) => {
  return (
    <section>
      {isLoading && (
        <div className="min-h-200 flex items-center justify-center">
          <CircularProgress size={30} color="secondary" />
        </div>
      )}
      {!isLoading && (
        <div className="flex">
          <div className="flex-1 pr-2">
            <Typography variant="h5" component="h2" color="">
              Your Favorite
            </Typography>
            <TableContainer component={Paper} style={{ maxHeight: '80vh' }}>
              <Table stickyHeader>
                <TableHead>
                  <TableRow>
                    <TableCell>Name</TableCell>
                    <TableCell></TableCell>
                  </TableRow>
                </TableHead>
                <TableBody>
                  <TableRow>
                    <TableCell>Carlos Alcaraz</TableCell>
                    <TableCell>
                      <div className="text-center">
                        <MuiButton title="Remove" style="" color="error" variant="contained" />
                      </div>
                    </TableCell>
                  </TableRow>
                </TableBody>
              </Table>
            </TableContainer>
          </div>
          <div className="flex-1">
            <Typography variant="h5" component="h2" color="">
              Players
            </Typography>
            <TableContainer component={Paper} style={{ maxHeight: '80vh' }}>
              <Table stickyHeader>
                <TableHead>
                  <TableRow>
                    <TableCell>ID</TableCell>
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
                      <TableCell>{player.id}</TableCell>
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
                          <MuiButton title="Add" style="" color="success" variant="contained" />
                        </div>
                      </TableCell>
                    </TableRow>
                  ))}
                </TableBody>
              </Table>
            </TableContainer>
          </div>
        </div>
      )}
    </section>
  )
}
